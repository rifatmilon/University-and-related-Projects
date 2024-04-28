#include <iostream>
#include <vector>
#include <cmath>
#include <numeric>
#include <map>

int main()
{
    const int rows = 8;
    const int cols = 8;

    std::vector<std::pair<int, int>> illumination_values1 = {{3, 4}, {4, 4}, {5, 4}, {3, 5}, {4, 5}, {5, 5}, {6, 5}, {5, 6}, {6, 6}};
    std::vector<std::vector<int>> matrix = create_matrix(rows, cols, illumination_values1);
    double m10, m01, m00;
    std::tie(m10, m01, m00) = calculate_moments(illumination_values1);

    std::cout << "For Shape 1:\n";
    print_matrix(matrix);
    print_moments(m10, m01, m00);
    print_rotation(rotation(m00, m10, m01));

    std::vector<std::pair<int, int>> illumination_values2 = {{4, 2}, {4, 3}, {3, 4}, {4, 4}, {5, 4}, {3, 5}, {4, 5}, {5, 5}, {6, 5}, {5, 6}, {6, 6}};
    std::vector<std::vector<int>> matrix2 = create_matrix(rows, cols, illumination_values2);
    std::tie(m10, m01, m00) = calculate_moments(illumination_values2);

    std::cout << "\nFor Shape 2:\n";
    print_matrix(matrix2);
    print_moments(m10, m01, m00);
    print_rotation(rotation(m00, m10, m01));

    // Example moment vectors for comparison
    std::vector<double> shape1_moment = {41, 44, 9, 345.679012345679, 336.19753086419746, -56.0109739369, -395.76406035665315, 1.3827160493827026, -19.204389574760093, 681.8765432098764, 97.5461057765591, 15.053411385271506, 282867.54540955665, 199143227.10978642, 2793753.5349092106, 439056951.9862907};
    std::vector<double> shape2_moment = {49, 49, 11, 336.1322314049587, 336.1322314049585, 45.824192336589384, 45.824192336589434, 0.13223140495868257, 15.278737791134624, 672.2644628099172, 0.06994057782938841, 0.00028901065218919384, 7467.13614038705, -9.89530235528946e-10, 1974.7798057222678, -10969.530226093655};

    std::cout << "\nComparison:\n";
    comparison(shape1_moment, shape2_moment);

    return 0;
}

std::vector<std::vector<int>> create_matrix(int rows, int cols, const std::vector<std::pair<int, int>> &illumination_values)
{
    std::vector<std::vector<int>> matrix(rows, std::vector<int>(cols, 0));
    for (const auto &[x, y] : illumination_values)
    {
        matrix[y - 1][x - 1] = 1; // Swap x and y indices
    }
    return matrix;
}

std::tuple<double, double, double> calculate_moments(const std::vector<std::pair<int, int>> &illumination_values)
{
    double m00 = 0, m10 = 0, m01 = 0;
    for (const auto &[x, y] : illumination_values)
    {
        m00 += 1;
        m10 += x;
        m01 += y;
    }
    return std::make_tuple(m10, m01, m00);
}

void print_matrix(const std::vector<std::vector<int>> &matrix)
{
    std::cout << "Binary Matrix:\n";
    for (const auto &row : matrix)
    {
        for (int value : row)
        {
            std::cout << value << " ";
        }
        std::cout << "\n";
    }
}

void print_moments(double m10, double m01, double m00)
{
    std::cout << "\nMoments:\n";
    std::cout << "m10: " << m10 << "\n";
    std::cout << "m01: " << m01 << "\n";
    std::cout << "m00: " << m00 << "\n";
}

std::map<std::pair<int, int>, double> rotation(double m00, double m10, double m01)
{
    std::map<std::pair<int, int>, double> moments;
    for (int p = 0; p < 4; ++p)
    {
        for (int q = 0; q < 4; ++q)
        {
            double moment = 0;
            for (int x = 1; x <= 8; ++x)
            {
                for (int y = 1; y <= 8; ++y)
                {
                    moment += std::pow((x - (m10 / m00)), p) * std::pow((y - (m01 / m00)), q);
                }
            }
            moments[{p, q}] = moment;
        }
    }
    return moments;
}

void print_rotation(const std::map<std::pair<int, int>, double> &moments)
{
    std::cout << "μ02: " << moments.at({0, 2}) << "\n";
    std::cout << "μ20: " << moments.at({2, 0}) << "\n";
    std::cout << "μ30: " << moments.at({3, 0}) << "\n";
    std::cout << "μ03: " << moments.at({0, 3}) << "\n";
    std::cout << "μ11: " << moments.at({1, 1}) << "\n";
    std::cout << "μ12: " << moments.at({1, 2}) << "\n";

    double R1 = moments.at({0, 2}) + moments.at({2, 0});
    double R2 = std::pow((moments.at({2, 0}) - moments.at({0, 2})), 2) + 4 * std::pow(moments.at({1, 1}), 2);
    double R3 = std::pow((moments.at({3, 0}) - 3 * moments.at({1, 2})), 2) + std::pow((3 * moments.at({2, 1})) - moments.at({0, 3}), 2);
    double R4 = std::pow(moments.at({3, 0}) + moments.at({1, 2}), 2) + std::pow(moments.at({2, 1}) + moments.at({0, 3}), 2);
    double R5 = (moments.at({3, 0}) - 3 * moments.at({1, 2})) + (moments.at({3, 0}) + moments.at({1, 2})) * std::pow((moments.at({3, 0}) + moments.at({1, 2})), 2) - (3 * std::pow(moments.at({2, 1}) + moments.at({0, 3}), 2)) + (3 * moments.at({2, 1}) - moments.at({0, 3})) + (moments.at({2, 1}) + moments.at({0, 3})) * (3 * std::pow(moments.at({3, 0}) + moments.at({1, 2}), 2) - std::pow(moments.at({2, 1}) + moments.at({0, 3}), 2));
    double R6 = (moments.at({2, 0}) - moments.at({0, 2})) * (std::pow(moments.at({3, 0}) + moments.at({1, 2}), 2) - std::pow(moments.at({2, 1}) + moments.at({0, 3}), 2)) + 4 * moments.at({1, 1}) * (moments.at({3, 0}) + moments.at({1, 2})) * (moments.at({2, 1}) + moments.at({0, 3}));
    double R7 = (3 * moments.at({2, 1}) - moments.at({0, 3})) * (moments.at({3, 0}) + moments.at({1, 2})) * (std::pow(moments.at({3, 0}) + moments.at({1, 2}), 2) - 3 * std::pow(moments.at({2, 1}) + moments.at({0, 3}), 2)) + (moments.at({3, 0}) - 3 * moments.at({1, 2})) * (moments.at({2, 1}) + moments.at({0, 3})) * (3 * std::pow(moments.at({3, 0}) + moments.at({1, 2}), 2) - std::pow(moments.at({2, 1}) + moments.at({0, 3}), 2));

    std::cout << "rotation1: " << R1 << "\n";
    std::cout << "rotation2: " << R2 << "\n";
    std::cout << "rotation3: " << R3 << "\n";
    std::cout << "rotation4: " << R4 << "\n";
    std::cout << "rotation5: " << R5 << "\n";
    std::cout << "rotation6: " << R6 << "\n";
    std::cout << "rotation7: " << R7 << "\n";
}

void comparison(const std::vector<double> &shape1_moments, const std::vector<double> &shape2_moments)
{
    // Euclidean distance
    double euclidean_distance = 0;
    for (int i = 0; i < shape1_moments.size(); ++i)
    {
        euclidean_distance += std::pow(shape1_moments[i] - shape2_moments[i], 2);
    }
    euclidean_distance = std::sqrt(euclidean_distance);

    // Cosine similarity
    double shape1_norm = std::sqrt(std::inner_product(shape1_moments.begin(), shape1_moments.end(), shape1_moments.begin(), 0.0));
    double shape2_norm = std::sqrt(std::inner_product(shape2_moments.begin(), shape2_moments.end(), shape2_moments.begin(), 0.0));
    double cosine_similarity = std::inner_product(shape1_moments.begin(), shape1_moments.end(), shape2_moments.begin(), 0.0) / (shape1_norm * shape2_norm);
    cosine_similarity = 1 - cosine_similarity;

    // Correlation coefficient
    double sum_sq_x = 0, sum_sq_y = 0, sum_coproduct = 0;
    double mean_x = std::accumulate(shape1_moments.begin(), shape1_moments.end(), 0.0) / shape1_moments.size();
    double mean_y = std::accumulate(shape2_moments.begin(), shape2_moments.end(), 0.0) / shape2_moments.size();

    for (int i = 0; i < shape1_moments.size(); ++i)
    {
        double sweep_x = shape1_moments[i] - mean_x;
        double sweep_y = shape2_moments[i] - mean_y;
        sum_sq_x += sweep_x * sweep_x;
        sum_sq_y += sweep_y * sweep_y;
        sum_coproduct += sweep_x * sweep_y;
    }

    double correlation_coefficient = sum_coproduct / std::sqrt(sum_sq_x * sum_sq_y);

    // Print the comparison results
    std::cout << "Euclidean Distance: " << euclidean_distance << "\n";
    std::cout << "Cosine Similarity: " << cosine_similarity << "\n";
    std::cout << "Correlation Coefficient: " << correlation_coefficient << "\n";
}